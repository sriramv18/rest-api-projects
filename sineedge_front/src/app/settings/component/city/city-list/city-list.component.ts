import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { CityDialogComponent } from '../city-dialog/city-dialog.component';
import { City } from '../../../model/city';


@Component({
  selector: 'app-city-list',
  templateUrl: './city-list.component.html',
  styleUrls: ['./city-list.component.scss']
})
export class CityListComponent implements OnInit {

  isPopupOpened = true;
  //, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  displayedColumns = ['city_id', 'fk_state_id', 'name', 'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get CityList() {
  //    return this._MastersService.getAllCity();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addCity() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(CityDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editCity(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllCity().find(c => c.ID === id);
    const dialogRef = this.dialog.open(CityDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteCity(id: number) {
    this._MastersService.deleteMasterDetails(id,'CITY');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<City[]> {
    //return this.userService.getUser();
    return this._bs.getAllCity();
  }
  disconnect() {}
}

