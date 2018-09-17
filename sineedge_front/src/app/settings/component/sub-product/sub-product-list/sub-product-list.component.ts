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
import { SubProductDialogComponent } from '../sub-product-dialog/sub-product-dialog.component';
import { SubProductMaster } from '../../../model/sub-product-master';

@Component({
  selector: 'app-sub-product-list',
  templateUrl: './sub-product-list.component.html',
  styleUrls: ['./sub-product-list.component.scss']
})
export class SubProductListComponent implements OnInit {

  isPopupOpened = true;

  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get SubProductMasterList() {
  //    return this._MastersService.getAllSubProductMaster();
  //  }

  displayedColumns = ['subproduct_id','fk_product_id','name','abbr','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  //subproduct_id, fk_product_id, name, abbr, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  
  dataSource = new UserDataSource(this._MastersService);

  
  ngOnInit() {
  }


  addSubProductMaster() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(SubProductDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editSubProductMaster(arr : any) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllSubProductMaster().find(c => c.ID === id);
    const dialogRef = this.dialog.open(SubProductDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteSubProductMaster(id: number) {
    this._MastersService.deleteMasterDetails(id,'SUBPRODUCTS');
  }
}

export class UserDataSource extends DataSource<any> {
  
  constructor(private _sps:MastersService ) {
    super();
  }

  connect(): Observable<SubProductMaster[]> {
    //return this.userService.getUser();
    return this._sps.getAllSubProductMaster();
  }
  disconnect() {}
}
