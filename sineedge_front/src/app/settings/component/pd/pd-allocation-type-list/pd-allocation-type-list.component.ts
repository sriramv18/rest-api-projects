import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { PdAllocationTypeDialogComponent } from '../pd-allocation-type-dialog/pd-allocation-type-dialog.component';
import { PdAllocationType } from '../../../model/pd';


@Component({
  selector: 'app-pd-allocation-type-list',
  templateUrl: './pd-allocation-type-list.component.html',
  styleUrls: ['./pd-allocation-type-list.component.scss']
})
export class PdAllocationTypeListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['pd_allocation_type_id','pd_allocation_type_name','isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get PDAllocationTypeList() {
  //    return this._MastersService.getAllPDAllocationType();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addPDAllocationType() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(PdAllocationTypeDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editPDAllocationType(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllPDAllocationType().find(c => c.ID === id);
    const dialogRef = this.dialog.open(PdAllocationTypeDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deletePDAllocationType(id: number) {
    this._MastersService.deleteMasterDetails(id,'PDALLOCATIONTYPE');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<PdAllocationType[]> {
    //return this.userService.getUser();
    return this._bs.getAllPDAllocationType();
  }
  disconnect() {}
}

