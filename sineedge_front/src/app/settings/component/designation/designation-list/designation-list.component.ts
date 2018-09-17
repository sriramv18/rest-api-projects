import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { DesignationDialogComponent } from '../designation-dialog/designation-dialog.component';
import { Designation } from '../../../model/designation';


@Component({
  selector: 'app-designation-list',
  templateUrl: './designation-list.component.html',
  styleUrls: ['./designation-list.component.scss']
})
export class DesignationListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['designation_id', 'name', 'short_name','isactive','actions'];
  

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get DesignationList() {
  //    return this._MastersService.getAllDesignation();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addDesignation() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(DesignationDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editDesignation(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllDesignation().find(c => c.ID === id);
    const dialogRef = this.dialog.open(DesignationDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteDesignation(id: number) {
    this._MastersService.deleteMasterDetails(id,'DESIGNATION');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<Designation[]> {
    //return this.userService.getUser();
    return this._bs.getAllDesignation();
  }
  disconnect() {}
}