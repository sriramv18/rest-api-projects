import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { CompanyDialogComponent } from '../company-dialog/company-dialog.component';
import { Company } from '../../../model/company';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-company-list',
  templateUrl: './company-list.component.html',
  styleUrls: ['./company-list.component.scss']
})
export class CompanyListComponent implements OnInit {

  isPopupOpened = true;
  //displayedColumns = ['Company_id', 'fk_city_id', 'name', 'createdon', 'fk_createdby', 'updatedon', 'fk_updatedby', 'isactive','actions'];
  displayedColumns = ['company_id', 'name', 'addressline1', 'addressline2','addressline3', 'city', 'state',  'pincode', 'logo','action'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get CompanyList() {
  //    return this._MastersService.getAllCompany();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addCompany() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(CompanyDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editCompany(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllCompany().find(c => c.ID === id);
    const dialogRef = this.dialog.open(CompanyDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteCompany(id: number) {
    this._MastersService.deleteMasterDetails(id,'COMPANY');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<Company[]> {
    //return this.userService.getUser();
    return this._bs.getAllCompany();
  }
  disconnect() {}
}
