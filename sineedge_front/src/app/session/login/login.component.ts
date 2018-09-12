import { Component, OnInit ,ViewEncapsulation } from '@angular/core';
import {Router} from "@angular/router";
import { AwsService } from '../../aws.service';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { CustomValidators } from 'ng2-validation';

import { MatDialog, MatDialogRef, MatDialogConfig } from '@angular/material';

@Component({
   selector: 'ms-login-session',
   templateUrl:'./login-component.html',
   styleUrls: ['./login-component.scss'],
   encapsulation: ViewEncapsulation.None,
})
export class LoginComponent { 
	changepass:FormGroup;
  email: string;
  password: string;
  newpassword:any;
  confirmPassword:any;
  changePassword:any;
status :Boolean= false;
  config: MatDialogConfig = {
    disableClose: false,
    width: '',
    height: '',
    position: {
      top: '',
      bottom: '',
      left: '',
      right: ''
    }
  };
  constructor(
    private router: Router,public aws:AwsService,public dialog: MatDialog
  ) { 
    
  }

  login() {
    let auth = {'Username':this.email,'Password':this.password};
    this.aws.dologin(auth).subscribe(res=>{
      console.log(res);
      if(res !== undefined){
    this.router.navigate(['/home']);
    }
  },err=>{
    console.log(err.message);
    if(err.message == "New password is required."){
     console.log("if");
     this.newpassopen();
    }else{
      console.log("else");
      
    }
     //alert(err.message);
  })
  }
	
  newpassopen() {
    let dialogRef = this.dialog.open(NewPasswordDialog,this.config);
    dialogRef.afterClosed().subscribe(result => {
      if(result !==undefined){
      let auth = {'Username':this.email,'Password':this.password,'newpassword':result};
      console.log(auth);
      this.aws.dologin(auth).subscribe(res=>{
        console.log(res);
      this.router.navigate(['/home']);
    },err=>{
      // alert(err.message);
    })
  }
    });
  }

  forgotopen() {
    this.status = true;
  }
  forgotpassword(){
    
      let auth = {'Username':this.email};
      console.log(auth);
        this.aws.userforgotpass(auth).subscribe(res=>{
          console.log(res);

        })
      
        
    
  }
    
}
const newpassword = new FormControl('', Validators.required);
const confirmPassword = new FormControl('', CustomValidators.equalTo(newpassword));
@Component({
  selector: 'app-jazz-dialog',
  template: `
  <h5 class="mt-0">New Password Change.</h5>
  
  <mat-form-field>
    <input matInput placeholder="New Password" #newpassword type="password" style="width: 100%;">
    
  </mat-form-field>
  

  <br/>
  <mat-form-field> 
  <input matInput placeholder="ConfirmPassword"  #confirmPassword type="password" style="width: 100%;">
  </mat-form-field>
  
  <small *ngIf="confirmPassword.value !='' && newpassword.value != confirmPassword.value" class="mat-text-warn">Passwords do not math.</small>

  <br>
        
            <button mat-raised-button class="mat-green" type="submit" (click)="dialogRef.close(newpassword.value)">Submit</button>
        
    
      `
})
export class NewPasswordDialog{
  
  newpassword:any = newpassword;
  confirmPassword:any = confirmPassword;
  jazzMessage = 'Jazzy jazz jazz';
  
  constructor(public dialogRef: MatDialogRef <NewPasswordDialog>) {
   
  }
  
  
}

@Component({
  selector: 'app-jazz-dialog',
  template: `
  <h5 class="mt-0">Forgot Password</h5>
  
  <mat-form-field>
    <input matInput placeholder="Email Id" #newpassword type="Email" style="width: 100%;">
    
  </mat-form-field>
  

  
  <br>
        
            <button mat-raised-button class="mat-green" type="submit" (click)="dialogRef.close(newpassword.value)">Submit</button>
        
    
      `
})
export class ForgotPass{
  
  newpassword:any = newpassword;
  confirmPassword:any = confirmPassword;
  jazzMessage = 'Jazzy jazz jazz';
  
  constructor(public dialogRef: MatDialogRef <ForgotPass>) {
   
  }
  
  
}


