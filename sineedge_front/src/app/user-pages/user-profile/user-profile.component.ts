import { Component, OnInit,ViewEncapsulation } from '@angular/core';
import { AwsService } from '../../aws.service';
import { MatDialog, MatDialogRef, MatDialogConfig } from '@angular/material';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { CustomValidators } from 'ng2-validation';
@Component({
    selector: 'ms-user-profile',
    templateUrl:'./user-profile-component.html',
    styleUrls: ['./user-profile-component.scss'],
    encapsulation: ViewEncapsulation.None
})
export class UserProfileComponent implements OnInit {
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
  constructor(public AWS:AwsService,public dialog: MatDialog) {}

  ngOnInit() {
    
    this.getuser();
    
  }
  
  getuser(){
    console.log(this.AWS.getUser());
  }
  changePassword(){
    let dialogRef = this.dialog.open(ChangePasswordDialog,this.config);
    dialogRef.afterClosed().subscribe(result => {
      
      console.log(result);
      if(result.confirmPassword !="" && result.newPassword !="" && result.oldPassword !=""){
        this.AWS.changepassword(result)
        .subscribe(res=>{
            alert('Change Password');
        })
      }
      //console.log(ChangePasswordDialog.prototype.pass);
    });
  }
}

@Component({
  selector: 'app-jazz-dialog',
  template: `
  <h5 class="mt-0">New Password Change.</h5>
  <mat-form-field>
    <input matInput placeholder="Old Password" [(ngModel)]="pass.oldPassword" type="password" style="width: 100%;">
    
  </mat-form-field>
  <br/>
  <mat-form-field>
    <input matInput placeholder="New Password" [(ngModel)]="pass.newPassword" type="password" style="width: 100%;">
    
  </mat-form-field>
  

  <br/>
  <mat-form-field> 
  <input matInput placeholder="ConfirmPassword"  [(ngModel)]="pass.confirmPassword" type="password" style="width: 100%;">
  </mat-form-field>
  
  <small *ngIf="pass.confirmPassword !='' && pass.newPassword != pass.confirmPassword" class="mat-text-warn">Passwords do not math.</small>

  <br>
        
            <button mat-raised-button class="mat-green" type="submit" (click)="dialogRef.close(pass)">Submit</button>
        
    
      `
})
export class ChangePasswordDialog{
  
  pass = {
    oldPassword:'',
    newPassword:'',
    confirmPassword:'',

  }
  
  jazzMessage = 'Jazzy jazz jazz';
  
  constructor(public dialogRef: MatDialogRef <ChangePasswordDialog>,public aws:AwsService) {
    
  }
  
  
}



