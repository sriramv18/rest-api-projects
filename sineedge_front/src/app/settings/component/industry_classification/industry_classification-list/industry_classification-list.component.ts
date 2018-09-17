import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { IndustryClassificationDialogComponent } from '../industry_classification-dialog/industry_classification-dialog.component';
import {  IndustryClassification } from '../../../model/industry_classification';

@Component({
  selector: 'app-industry_classification-list',
  templateUrl: './industry_classification-list.component.html',
  styleUrls: ['./industry_classification-list.component.scss']
})


// export class TablePagingComponent implements OnInit {
  
// }

export class IndustryClassificationListComponent implements OnInit {


  isPopupOpened = true;

  displayedColumns = ['industry_classification_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  //industry_classification_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  
  constructor(private dialog: MatDialog,
    private _IMService: MastersService) { }

  //  get IndustryClassificationList() {
  //    return this._IMService.getAllIndustryClassification();
  //  }

  //displayedColumns: string[] = ['ID','ClassifiedName'];
  dataSource = new UserDataSource(this._IMService);

  
  ngOnInit() {}


  addIndustryClassification() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(IndustryClassificationDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editIndustryClassification(arr: any) {
    this.isPopupOpened = true;
    //const indu = this._IMService.getAllIndustryClassification().find(c => c.ID === id);
    const dialogRef = this.dialog.open(IndustryClassificationDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteIndustryClassification(id: number) {
    this._IMService.deleteMasterDetails(id,'INDUSTRYCLASSIFICATION');
  }

}



export class UserDataSource extends DataSource<any> {
  
  constructor(private _ims: MastersService ) {
    super();
  }

  connect(): Observable<IndustryClassification[]> {
    //return this.userService.getUser();
    return this._ims.getAllIndustryClassification();
  }
  disconnect() {}
}