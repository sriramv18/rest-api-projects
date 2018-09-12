import { Component, OnInit ,ViewEncapsulation } from '@angular/core';
import {Router} from "@angular/router";
import { AwsLenderService } from '../../awsLender.service';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { CustomValidators } from 'ng2-validation';

import { MatDialog, MatDialogRef, MatDialogConfig } from '@angular/material';

@Component({
   selector: 'ms-loginHome-session',
   templateUrl:'./loginHome-component.html',
   styleUrls: ['./loginHome-component.scss'],
   encapsulation: ViewEncapsulation.None,
})
export class loginHomeComponent {
	
  constructor(
    private router: Router,public aws:AwsLenderService,public dialog: MatDialog
  ) { 
    
  }

  sineedgeLogin(){
    this.router.navigate(['authentication/login']);
  }
  
  lenderLogin(){
    this.router.navigate(['authentication/lenderlogin']);
  }
  
}


