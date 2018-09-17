import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { PdTypeDialogComponent } from '../pd-type-dialog/pd-type-dialog.component';
import { PdType } from '../../../model/pd';


@Component({
  selector: 'app-pd-type-list',
  templateUrl: './pd-type-list.component.html',
  styleUrls: ['./pd-type-list.component.scss']
})
export class PdTypeListComponent implements OnInit {


  isPopupOpened = true;
  displayedColumns = ['pd_type_id', 'type_name', 'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _PDTypeService: MastersService) { }

  //  get PDTypeList() {
  //    return this._PDTypeService.getAllPDType();
  //  }

  dataSource = new UserDataSource(this._PDTypeService);
  
  ngOnInit() {
  }


  addPDType() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(PdTypeDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editPDType(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._PDTypeService.getAllPDType().find(c => c.ID === id);
    const dialogRef = this.dialog.open(PdTypeDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deletePDType(id: number) {
    this._PDTypeService.deleteMasterDetails(id,'PDTYPE');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<PdType[]> {
    //return this.userService.getUser();
    return this._bs.getAllPDType();
  }
  disconnect() {}
}


