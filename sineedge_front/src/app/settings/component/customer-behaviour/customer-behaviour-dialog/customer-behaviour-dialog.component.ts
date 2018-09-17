import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './customer-behaviour-dialog.component.html',
  styleUrls: ['./customer-behaviour-dialog.component.scss']
})
export class CustomerBehaviourDialogComponent implements OnInit {

  public _customerBehaviourForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<CustomerBehaviourDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._customerBehaviourForm = this._formBuilder.group({
        //branch_id: any; fk_city_id: any;
        customer_behaviour_id: [this.data.customer_behaviour_id],
        description: [this.data.description, Validators.compose([Validators.required])]
          
      });
      //customer_behaviour_id, description, createdon, fk_createdby, updatedon, fk_updatedby, isactive
    //console.log(this._customerBehaviourForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addBranch(this._customerBehaviourForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editBranch(this._customerBehaviourForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.customer_behaviour_id)) {
      var my_array = this._customerBehaviourForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'CUSTOMERBEHAVIOUR').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._customerBehaviourForm.value,'CUSTOMERBEHAVIOUR').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._customerBehaviourForm.reset();
  }
}
