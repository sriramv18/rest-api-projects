import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './activity-dialog.component.html',
  styleUrls: ['./activity-dialog.component.scss']
})
export class ActivityDialogComponent implements OnInit {

  public _activityMasterForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<ActivityDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._activityMasterForm = this._formBuilder.group({
          type_of_activity_id: [this.data.type_of_activity_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._activityMasterForm);
  }

  onSubmit() {
    if(isNaN(this.data.type_of_activity_id)) {
      var my_array = this._activityMasterForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'TYPEOFACTIVITY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._activityMasterForm.value,'TYPEOFACTIVITY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addActivity(this._activityMasterForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editActivity(this._activityMasterForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onReset(){
    this._activityMasterForm.reset();
  }
}
