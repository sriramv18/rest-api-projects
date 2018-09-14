import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';

import { MastersService } from '../../../service/master/masters.service';
import { BranchDialogComponent } from '../branch-dialog/branch-dialog.component';
import { Branch,States,City } from '../../../model/branch';

@Component({
  selector: 'app-branch-list',
  templateUrl: './branch-list.component.html',
  styleUrls: ['./branch-list.component.scss']
})
export class BranchListComponent implements OnInit {

  
  isPopupOpened = true;
  isactive:number;
  

  constructor(private dialog: MatDialog,
    private _mastersService: MastersService) { }

  ngOnInit() {}

  displayedColumns = ['branch_id','name','fk_city_id','cname', 'isactive','actions'];
  dataSource = new UserDataSource(this._mastersService);

  /** Popup for ADD Branch */
  addBranch() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(BranchDialogComponent, {
      data: {}
    });

    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  /** Popup for EDIT Branch */
  editBranch(arr: Branch[]) {
    this.isPopupOpened = true;
  
    const dialogRef = this.dialog.open(BranchDialogComponent, {
      data: arr
    });

    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  /** Popup for EDIT Branch */
  deleteBranch(id: number) {
    
    this._mastersService.deleteMasterDetails(id,'BRANCH').subscribe();
    
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _ms: MastersService) {
    super();
  }

  connect(): Observable<Branch[]> {
    //return this.userService.getUser();
    //return this._bs.getAllBranch();
    console.log(this._ms.getAllBranch());
    return this._ms.getAllBranch();
  }
  disconnect() {}
}
