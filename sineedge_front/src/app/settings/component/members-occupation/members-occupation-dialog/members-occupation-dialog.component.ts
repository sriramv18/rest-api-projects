import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './members-occupation-dialog.component.html',
  styleUrls: ['./members-occupation-dialog.component.scss']
})
export class MembersOccupationDialogComponent implements OnInit {


  public _occupationForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<MembersOccupationDialogComponent>,
  private _memberService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._occupationForm = this._formBuilder.group({
        occupation_non_earning_member_id: [this.data.occupation_non_earning_member_id],
          name: [this.data.name, Validators.compose([Validators.required])]
      });
    //console.log(this._occupationForm);
  }

  onSubmit() {
    if(isNaN(this.data.occupation_non_earning_member_id)) {
      var my_array = this._occupationForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._memberService.addMasterDetails(my_array,'OCCUPATIONMEMBERS').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      this._memberService.editMasterDetails(this._occupationForm.value,'OCCUPATIONMEMBERS').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._memberService.addMembersOccupation(this._occupationForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._memberService.editMembersOccupation(this._occupationForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onReset(){
    this._occupationForm.reset();
  }
}

