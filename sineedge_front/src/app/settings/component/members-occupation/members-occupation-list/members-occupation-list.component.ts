import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { MembersOccupationDialogComponent } from '../members-occupation-dialog/members-occupation-dialog.component';
import { MembersOccupation } from '../../../model/members-occupation';


@Component({
  selector: 'app-members-occupation-list',
  templateUrl: './members-occupation-list.component.html',
  styleUrls: ['./members-occupation-list.component.scss']
})
export class MembersOccupationListComponent implements OnInit {

  isPopupOpened = true;

  displayedColumns = ['occupation_non_earning_member_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  //occupation_non_earning_member_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;


  constructor(private dialog: MatDialog,
    private _memberService: MastersService) { }

  //  get MemberOccupationList() {
  //    return this._memberService.getAllMembersOccupation();
  //  }

  ngOnInit() {}

  dataSource = new UserDataSource(this._memberService);

  addMemberOccupation() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(MembersOccupationDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editMemberOccupation(arr : any) {
    this.isPopupOpened = true;
    //const contact = this._memberService.getAllMembersOccupation().find(c => c.ID === id);
    const dialogRef = this.dialog.open(MembersOccupationDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteMemberOccupation(id: number) {
    this._memberService.deleteMasterDetails(id,'OCCUPATIONMEMBERS');
  }
}



export class UserDataSource extends DataSource<any> {
  
  constructor(private _mos:MastersService ) {
    super();
  }

  connect(): Observable<MembersOccupation[]> {
    //return this.userService.getUser();
    return this._mos.getAllMembersOccupation();
  }
  disconnect() {}
}