import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './pd-location-approach-dialog.component.html',
  styleUrls: ['./pd-location-approach-dialog.component.scss']
})
export class PdLocationApproachDialogComponent implements OnInit {

  public _pdLocationApproachForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<PdLocationApproachDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  //pd_location_approach_id, description, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  ngOnInit() {

      this._pdLocationApproachForm = this._formBuilder.group({
        //branch_id: any; fk_city_id: any;
          pd_location_approach_id: [this.data.pd_location_approach_id],
          description: [this.data.description, Validators.compose([Validators.required])]
      });
    //console.log(this._pdLocationApproachForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addBranch(this._pdLocationApproachForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editBranch(this._pdLocationApproachForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.pd_location_approach_id)) {
      var my_array = this._pdLocationApproachForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'PDLOCATIONAPPROACH').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._pdLocationApproachForm.value,'PDLOCATIONAPPROACH').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._pdLocationApproachForm.reset();
  }
}










