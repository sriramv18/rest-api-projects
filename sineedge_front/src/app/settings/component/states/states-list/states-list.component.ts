import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';

import { MastersService } from '../../../service/master/masters.service';
import { StatesDialogComponent } from '../states-dialog/states-dialog.component';
import { States } from '../../../model/states';


@Component({
  selector: 'app-states-list',
  templateUrl: './states-list.component.html',
  styleUrls: ['./states-list.component.scss']
})
export class StatesListComponent implements OnInit {

  isPopupOpened = true;
  //displayedColumns = ['states_id', 'fk_city_id', 'name', 'createdon', 'fk_createdby', 'updatedon', 'fk_updatedby', 'isactive','actions'];
  displayedColumns = ['state_id', 'fk_region_id', 'name', 'code', 'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _statesService: MastersService) { }

  //  get StatesList() {
  //    return this._statesService.getAllStates();
  //  }

  dataSource = new UserDataSource(this._statesService);
  
  ngOnInit() {
  }


  addState() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(StatesDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editState(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._statesService.getAllStates().find(c => c.ID === id);
    const dialogRef = this.dialog.open(StatesDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteState(id: number) {
    this._statesService.deleteMasterDetails(id,'');
  }

  
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<States[]> {
    //return this.userService.getUser();
    return this._bs.getAllState();
  }
  disconnect() {}
}
