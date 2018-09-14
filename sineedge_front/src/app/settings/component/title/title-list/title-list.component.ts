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
import { TitleDialogComponent } from '../title-dialog/title-dialog.component';
import { Title } from '../../../model/title';

@Component({
  selector: 'app-title-list',
  templateUrl: './title-list.component.html',
  styleUrls: ['./title-list.component.scss']
})
export class TitleListComponent implements OnInit {

  isPopupOpened = true;

  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  displayedColumns = ['title_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];

  //title_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  
  dataSource = new UserDataSource(this._MastersService);


  //  get TitleList() {
  //    return this._MastersService.getAllTitle();
  //  }

  
  ngOnInit() {
  }


  addTitle() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(TitleDialogComponent , {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editTitle(arr : any) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllTitle().find(c => c.ID === id);
    const dialogRef = this.dialog.open(TitleDialogComponent , {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteTitle(id: number) {
    this._MastersService.deleteMasterDetails(id,'TITLES');
  }
}

export class UserDataSource extends DataSource<any> {
  
  constructor(private _ts:MastersService ) {
    super();
  }

  connect(): Observable<Title[]> {
    //return this.userService.getUser();
    return this._ts.getAllTitle();
  }
  disconnect() {}
}