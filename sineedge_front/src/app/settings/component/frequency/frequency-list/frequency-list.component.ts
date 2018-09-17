import { Component, OnInit, OnDestroy, ViewChild } from '@angular/core';
import { MatDialog, MatDialogRef, MatDialogConfig,MatPaginator, MatSort,MatTableDataSource } from '@angular/material';

import { Observable, Subject } from 'rxjs';
import { Http, Response } from '@angular/http';
import 'rxjs/add/operator/map';

import { DataSource } from '@angular/cdk/collections';
import { map } from 'rxjs/operators';
import { of as observableOf, merge } from 'rxjs';


import { MastersService } from '../../../service/master/masters.service';
import { FrequencyDialogComponent }from '../frequency-dialog/frequency-dialog.component';
import { Frequency } from '../../../model/frequency';


@Component({
  selector: 'app-frequency-list',
  templateUrl: './frequency-list.component.html',
  styleUrls: ['./frequency-list.component.scss']
})
export class FrequencyListComponent implements OnInit {

  isPopupOpened = true;
  displayedColumns = ['frequency_id','name','createdon','fk_createdby','updatedon','isactive','fk_updatedby','actions'];
  
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  
  constructor(private dialog: MatDialog,
    private _MastersService: MastersService) { }

  //  get FrequencyList() {
  //    return this._MastersService. getAllFrequency();
  //  }

   dataSource = new UserDataSource(this._MastersService);
  
  ngOnInit() {
  }


  addFrequency() {
    this.isPopupOpened = true;
    const dialogRef = this.dialog.open(FrequencyDialogComponent, {
      data: {}
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  editFrequency(arr: any) {
    this.isPopupOpened = true;
    //const contact = this._MastersService.getAllFrequency().find(c => c.ID === id);
    const dialogRef = this.dialog.open(FrequencyDialogComponent, {
      data: arr
    });


    dialogRef.afterClosed().subscribe(result => {
      this.isPopupOpened = false;
    });
  }

  deleteFrequency(id: number) {
    this._MastersService.deleteMasterDetails(id,'FREQUENCY');
  }
}

export class UserDataSource extends DataSource<any> {
  

  constructor(private _fs: MastersService) {
    super();
  }

  connect(): Observable<Frequency[]> {
    //return this.userService.getUser();
    return this._fs.getAllFrequency();
  }
  disconnect() {}
}