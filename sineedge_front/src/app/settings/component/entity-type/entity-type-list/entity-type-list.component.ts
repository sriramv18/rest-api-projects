import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { EntityTypeDialogComponent } from '../entity-type-dialog/entity-type-dialog.component';
import { EntityType } from '../../../model/entity-type';


@Component({
  selector: 'app-entity-type-list',
  templateUrl: './entity-type-list.component.html',
  styleUrls: ['./entity-type-list.component.scss']
})
export class EntityTypeListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['entity_type_id', 'name','isactive','actions'];
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  
  constructor(private dialog: MatDialog,
    private _EtService: MastersService) { }

  //  get EntityTypeList() {
  //    return this._EtService. getAllEntityType();
  //  }

   dataSource = new UserDataSource(this._EtService);
  
  ngOnInit() {
  }


  addEntityType() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(EntityTypeDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editEntityType(arr: any) {
    this.isPopupOpened = true;
    //const contact = this._EtService.getAllEntityType().find(c => c.ID === id);
    const dialogRef = this.dialog.open(EntityTypeDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteEntityType(id: number) {
    this._EtService.deleteMasterDetails(id,'ENTITYTYPE');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _ets: MastersService ) {
    super();
  }

  connect(): Observable<EntityType[]> {
    //return this.userService.getUser();
    return this._ets.getAllEntityType();
  }
  disconnect() {}
}