import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './customer-segment-dialog.component.html',
  styleUrls: ['./customer-segment-dialog.component.scss']
})
export class CustomerSegmentDialogComponent implements OnInit {

  public _customerSegmentForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<CustomerSegmentDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._customerSegmentForm = this._formBuilder.group({
        //CustomerSegment_id: any; fk_city_id: any;
        customer_segment_id: [this.data.customer_segment_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          abbr: [this.data.abbr, Validators.compose([Validators.required])]
      });
    //console.log(this._customerSegmentForm);
    //customer_segment_id, name, abbr, createdon, fk_createdby, updatedon, isactive, fk_updatedby
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addCustomerSegment(this._customerSegmentForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editCustomerSegment(this._customerSegmentForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.customer_segment_id)) {
      var my_array = this._customerSegmentForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'CUSTOMERSEGMENT').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._customerSegmentForm.value,'CUSTOMERSEGMENT').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._customerSegmentForm.reset();
  }
}






