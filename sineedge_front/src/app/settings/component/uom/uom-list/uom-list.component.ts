// import { Component, OnInit } from '@angular/core';
// import { MatDialog, MatPaginator, MatTableDataSource } from '@angular/material';

import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { UomDialogComponent } from '../uom-dialog/uom-dialog.component';
import { Uom } from '../../../model/uom';



@Component({
  selector: 'app-uom-list',
  templateUrl: './uom-list.component.html',
  styleUrls: ['./uom-list.component.scss']
})
export class UomListComponent implements OnInit {

  isPopupOpened = true;

  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get UOMList() {
  //    return this._MastersService.getAllUom();
  //  }
  
  ngOnInit() {
  }

  displayedColumns = ['uom_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  //uom_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  
  dataSource = new UserDataSource(this._MastersService);


  addUOM() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open( UomDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editUOM(arr : any) {
    this.isPopupOpened = true;
  //  const contact = this._MastersService.getAllUom().find(c => c.ID === id);
    const dialogRef = this.dialog.open( UomDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteUOM(id: number) {
    this._MastersService.deleteMasterDetails(id,'UOM');
  }
}


export class UserDataSource extends DataSource<any> {
  
  constructor(private _us:MastersService ) {
    super();
  }

  connect(): Observable<Uom[]> {
    //return this.userService.getUser();
    return this._us.getAllUom();
  }
  disconnect() {}
}



