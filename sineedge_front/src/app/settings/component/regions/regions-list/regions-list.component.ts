import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { RegionsDialogComponent } from '../regions-dialog/regions-dialog.component';
import { Regions } from '../../../model/regions';


@Component({
  selector: 'app-regions-list',
  templateUrl: './regions-list.component.html',
  styleUrls: ['./regions-list.component.scss']
})
export class RegionsListComponent implements OnInit {


  isPopupOpened = true;
  displayedColumns = ['region_id', 'name', 'isactive','actions'];
  //region_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  constructor(private dialog: MatDialog,
    private _regionsService: MastersService) { }

  //  get regionsList() {
  //    return this._regionsService.getAllregions();
  //  }

  dataSource = new UserDataSource(this._regionsService);
  
  ngOnInit() {
  }


  addregions() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(RegionsDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editregions(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._regionsService.getAllregions().find(c => c.ID === id);
    const dialogRef = this.dialog.open(RegionsDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteregions(id: number) {
    this._regionsService.deleteMasterDetails(id,'REGIONS');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<Regions[]> {
    //return this.userService.getUser();
    return this._bs.getAllRegion();
  }
  disconnect() {}
}

