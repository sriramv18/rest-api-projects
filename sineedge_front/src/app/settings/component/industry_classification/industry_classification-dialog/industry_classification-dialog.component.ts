import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './industry_classification-dialog.component.html',
  styleUrls: ['./industry_classification-dialog.component.scss']
})
export class IndustryClassificationDialogComponent implements OnInit {

  public _IndustryClassificationForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<IndustryClassificationDialogComponent>,
  private _contactService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._IndustryClassificationForm = this._formBuilder.group({
          industry_classification_id: [this.data.industry_classification_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._IndustryClassificationForm);
    //industry_classification_id, name, createdon, fk_createdby, updatedon, fk_updatedby, isactive
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._contactService.addIndustryClassification(this._IndustryClassificationForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._contactService.editIndustryClassification(this._IndustryClassificationForm.value);
  //     this.dialogRef.close();
  //   }
  // }


  onSubmit() {
    if(isNaN(this.data.industry_classification_id)) {
      var my_array = this._IndustryClassificationForm.value;
      Object.keys(my_array).forEach((key) => (my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._contactService.addMasterDetails(my_array,'INDUSTRYCLASSIFICATION').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._contactService.editMasterDetails(this._IndustryClassificationForm.value,'INDUSTRYCLASSIFICATION').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  onReset(){
    this._IndustryClassificationForm.reset();
  }
}
