import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';

import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './frequency-dialog.component.html',
  styleUrls: ['./frequency-dialog.component.scss']
})
export class FrequencyDialogComponent implements OnInit {


  public _frequencyForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<FrequencyDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._frequencyForm = this._formBuilder.group({
        frequency_id: [this.data.frequency_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._frequencyForm);
  }

  onSubmit() {
    if(isNaN(this.data.frequency_id)) {
      var my_array = this._frequencyForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'FREQUENCY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._MastersService.editMasterDetails( this._frequencyForm.value,'FREQUENCY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._contactService.addIndustryMaster(this._frequencyForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._contactService.editIndustryMaster(this._frequencyForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onReset(){
    this._frequencyForm.reset();
  }
}

