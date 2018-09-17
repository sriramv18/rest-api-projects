import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { CustomerBehaviourDialogComponent } from '../customer-behaviour-dialog/customer-behaviour-dialog.component';
import { CustomerBehaviour } from '../../../model/customer-behaviour';


@Component({
  selector: 'app-customer-behaviour-list',
  templateUrl: './customer-behaviour-list.component.html',
  styleUrls: ['./customer-behaviour-list.component.scss']
})
export class CustomerBehaviourListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['customer_behaviour_id', 'description', 'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get CustomerBehaviourList() {
  //    return this._MastersService.getAllCustomerBehaviour();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addCustomerBehaviour() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(CustomerBehaviourDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editCustomerBehaviour(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllCustomerBehaviour().find(c => c.ID === id);
    const dialogRef = this.dialog.open(CustomerBehaviourDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteCustomerBehaviour(id: number) {
    this._MastersService.deleteMasterDetails(id,'CUSTOMERBEHAVIOUR');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<CustomerBehaviour[]> {
    //return this.userService.getUser();
    return this._bs.getAllCustomerBehaviour();
  }
  disconnect() {}
}
