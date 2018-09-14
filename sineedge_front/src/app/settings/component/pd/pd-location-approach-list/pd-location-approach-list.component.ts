import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { PdLocationApproachDialogComponent } from '../pd-location-approach-dialog/pd-location-approach-dialog.component';
import { PdLocationApproach } from '../../../model/pd';


@Component({
  selector: 'app-pd-location-approach-list',
  templateUrl: './pd-location-approach-list.component.html',
  styleUrls: ['./pd-location-approach-list.component.scss']
})
export class PdLocationApproachListComponent implements OnInit {


  isPopupOpened = true;
  displayedColumns = ['pd_allocation_type_id', 'pd_allocation_type_name', 'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get PdLocationApproachList() {
  //    return this._MastersService.getAllPdLocationApproach();
  //  }

  //dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addPdLocationApproach() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(PdLocationApproachDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editPdLocationApproach(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllPdLocationApproach().find(c => c.ID === id);
    const dialogRef = this.dialog.open(PdLocationApproachDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deletePdLocationApproach(id: number) {
    this._MastersService.deleteMasterDetails(id,'PDLOCATIONAPPROACH');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<PdLocationApproach[]> {
    //return this.userService.getUser();
    return this._bs.getAllPDLocationApproach();
  }
  disconnect() {}
}


