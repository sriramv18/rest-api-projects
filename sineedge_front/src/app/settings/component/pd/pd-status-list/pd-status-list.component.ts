import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { PdStatusDialogComponent } from '../pd-status-dialog/pd-status-dialog.component';
import { PdStatus } from '../../../model/pd';


@Component({
  selector: 'app-pd-status-list',
  templateUrl: './pd-status-list.component.html',
  styleUrls: ['./pd-status-list.component.scss']
})
export class PdStatusListComponent implements OnInit {


  isPopupOpened = true;
  displayedColumns = ['pd_status_id', 'pd_status_name','isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _PdStatusService: MastersService) { }

  //  get PdStatusList() {
  //    return this._PdStatusService.getAllPdStatus();
  //  }

  dataSource = new UserDataSource(this._PdStatusService);
  
  ngOnInit() {
  }


  addPdStatus() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(PdStatusDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editPdStatus(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._PdStatusService.getAllPdStatus().find(c => c.ID === id);
    const dialogRef = this.dialog.open(PdStatusDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deletePdStatus(id: number) {
    this._PdStatusService.deleteMasterDetails(id,'PDSTATUS');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<PdStatus[]> {
    //return this.userService.getUser();
    return this._bs.getAllPDStatus();
  }
  disconnect() {}
}


