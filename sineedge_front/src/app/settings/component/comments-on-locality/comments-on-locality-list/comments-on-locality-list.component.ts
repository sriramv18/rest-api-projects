import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { CommentsOnLocalityDialogComponent } from '../comments-on-locality-dialog/comments-on-locality-dialog.component';
import { CommentsOnLocality } from '../../../model/comments-on-locality';


@Component({
  selector: 'app-comments-on-locality-list',
  templateUrl: './comments-on-locality-list.component.html',
  styleUrls: ['./comments-on-locality-list.component.scss']
})
export class CommentsOnLocalityListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['comments_on_locality_id','rating','isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
   
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get CommentsOnLocalityList() {
  //    return this._MastersService.getAllCommentsOnLocality();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addCommentsOnLocality() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(CommentsOnLocalityDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editCommentsOnLocality(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllCommentsOnLocality().find(c => c.ID === id);
    const dialogRef = this.dialog.open(CommentsOnLocalityDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteCommentsOnLocality(id: number) {
    this._MastersService.deleteMasterDetails(id,'COMMENTSONLOCALITY');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<CommentsOnLocality []> {
    //return this.userService.getUser();
    return this._bs.getAllCommentsOnLocality();
  }
  disconnect() {}
}
