
import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';
 
import { MastersService } from '../../../service/master/masters.service';
import { LenderHierarchyDialogComponent }from '../lender-hierarchy-dialog/lender-hierarchy-dialog.component';
import { LenderHierarchy } from '../../../model/lender-hierarchy';


@Component({
  selector: 'app-lender-hierarchy-list',
  templateUrl: './lender-hierarchy-list.component.html',
  styleUrls: ['./lender-hierarchy-list.component.scss']
})
export class LenderHierarchyListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['lender_hierarchy_id', 'lender_hierarchy','isactive','actions'];
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get LenderHierarchyList() {
  //    return this._MastersService. getAllLenderHierarchy();
  //  }

   dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addLenderHierarchy() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(LenderHierarchyDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editLenderHierarchy(arr: any) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllLenderHierarchy().find(c => c.ID === id);
    const dialogRef = this.dialog.open(LenderHierarchyDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteLenderHierarchy(id: number) {
    this._MastersService.deleteMasterDetails(id,'LENDERHIERARCHY');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _fs: MastersService ) {
    super();
  }

  connect(): Observable<LenderHierarchy[]> {
    //return this.userService.getUser();
    return this._fs.getAllLenderHierarchy();
  }
  disconnect() {}
}