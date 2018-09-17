import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { ActivityDialogComponent } from '../activity-dialog/activity-dialog.component';
import { Activity } from '../../../model/activity';

@Component({
  selector: 'app-activity-list',
  templateUrl: './activity-list.component.html',
  styleUrls: ['./activity-list.component.scss']
})
export class ActivityListComponent implements OnInit {

  isPopupOpened = true;

  displayedColumns = ['type_of_activity_id', 'name', 'createdon', 'fk_createdby', 'updatedon', 'fk_updatedby', 'isactive','actions'];
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

    dataSource = new UserDataSource(this._MastersService);
   
  ngOnInit() {}


  addActivity() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(ActivityDialogComponent, {
      data: {}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }


  editActivity(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllActivity().find(c => c.ID === id);
    const dialogRef = this.dialog.open(ActivityDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteActivity(id: number) {
    this._MastersService.deleteMasterDetails(id,'TYPEOFACTIVITY').subscribe();
  }

}


export class UserDataSource extends DataSource<any> {
  

  constructor(private _as:MastersService) {
    super();
  }

  connect(): Observable<Activity[]> {
    //return this.userService.getUser();
    return this._as.getAllActivity();
  }
  disconnect() {}
}