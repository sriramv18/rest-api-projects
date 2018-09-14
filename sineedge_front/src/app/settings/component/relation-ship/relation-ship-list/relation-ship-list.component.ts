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
import { RelationShipDialogComponent } from '../relation-ship-dialog/relation-ship-dialog.component';
import { RelationShip } from '../../../model/relation-ship';


@Component({
  selector: 'app-relation-ship-list',
  templateUrl: './relation-ship-list.component.html',
  styleUrls: ['./relation-ship-list.component.scss']
})
export class RelationShipListComponent implements OnInit {

  isPopupOpened = true;

  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get RelationShipList() {
  //    return this._MastersService.getAllRelationShip();
  //  }

  displayedColumns = ['relationship_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  //relationship_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  
  ngOnInit() {
  }

  dataSource = new UserDataSource(this._MastersService);

  addRelationShip() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(RelationShipDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editRelationShip(arr: any) {
    this.isPopupOpened = true;
  //  const contact = this._MastersService.getAllRelationShip().find(c => c.ID === id);
    const dialogRef = this.dialog.open(RelationShipDialogComponent, {

      data : arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteRelationShip(id: number) {
    this._MastersService.deleteMasterDetails(id,'RELATIONSHIPS');
  }
}



export class UserDataSource extends DataSource<any> {
  
  constructor(private _rss:MastersService ) {
    super();
  }

  connect(): Observable<RelationShip[]> {
    //return this.userService.getUser();
    return this._rss.getAllRelationShip();
  }
  disconnect() {}
}


