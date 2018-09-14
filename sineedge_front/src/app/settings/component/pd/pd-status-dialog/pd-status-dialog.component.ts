import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './pd-status-dialog.component.html',
  styleUrls: ['./pd-status-dialog.component.scss']
})
export class PdStatusDialogComponent implements OnInit {

  public _PdStatusForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<PdStatusDialogComponent>,
  private _PdStatusService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._PdStatusForm = this._formBuilder.group({
        
          pd_status_id: [this.data.pd_status_id],
          pd_status_name: [this.data.pd_status_name, Validators.compose([Validators.required])],
          
      });
    //console.log(this._PdStatusForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._PdStatusService.addPdStatus(this._PdStatusForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._PdStatusService.editPdStatus(this._PdStatusForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.pd_status_id)) {
      var my_array = this._PdStatusForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._PdStatusService.addMasterDetails(my_array,'PDSTATUS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._PdStatusService.editMasterDetails(this._PdStatusForm.value,'PDSTATUS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._PdStatusForm.reset();
  }
}