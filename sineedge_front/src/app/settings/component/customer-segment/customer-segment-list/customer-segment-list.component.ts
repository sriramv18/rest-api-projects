import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { CustomerSegmentDialogComponent } from '../customer-segment-dialog/customer-segment-dialog.component';
import { CustomerSegment } from '../../../model/customer-segment';


@Component({
  selector: 'app-customer-segment-list',
  templateUrl: './customer-segment-list.component.html',
  styleUrls: ['./customer-segment-list.component.scss']
})
export class CustomerSegmentListComponent implements OnInit {
  isPopupOpened = true;
  displayedColumns = ['customer_segment_id', 'abbr', 'name',  'isactive','actions'];

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
 
  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get CustomerSegmentList() {
  //    return this._MastersService.getAllCustomerSegment();
  //  }

  dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addCustomerSegment() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(CustomerSegmentDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editCustomerSegment(arr: any[]) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllCustomerSegment().find(c => c.ID === id);
    const dialogRef = this.dialog.open(CustomerSegmentDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteCustomerSegment(id: number) {
    this._MastersService.deleteMasterDetails(id,'CUSTOMERSEGMENT');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _bs: MastersService) {
    super();
  }

  connect(): Observable<CustomerSegment[]> {
    //return this.userService.getUser();
    return this._bs.getAllCustomerSegment();
  }
  disconnect() {}
}
