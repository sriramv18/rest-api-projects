import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';
import { States } from '../../../model/states';

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './states-dialog.component.html',
  styleUrls: ['./states-dialog.component.scss']
})
export class StatesDialogComponent implements OnInit {

  public _statesForm: FormGroup;
  foundBooks: any;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<StatesDialogComponent>,
  private _MastersService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }

    // get RegionData(){
    //   return this._MastersService.getRegionData().subscribe(
    //            data => { this.foundBooks = data });
    // }

    // getBooks() 
    //   {
    //     this._MastersService.getRegionData().subscribe(
    //       data => { this.foundBooks = data.json();
    //                 this.foundBooks = Array.of(this.foundBooks); 
    //        },
    //       err => console.error(err), 
    //       () => console.log('getBooks completed') 
    //       );
    //  }

   

  ngOnInit() {
      // console.log(this._MastersService.getRegionData());
      //console.log('RegionData',this.RegionData);
      //console.log('getBooks',this.getBooks);
      //console.log('foundBooks',this.foundBooks);

      this._statesForm = this._formBuilder.group({
        //States_id: any; fk_city_id: any;
          state_id: [this.data.state_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          code: [this.data.code, Validators.compose([Validators.required])],
          fk_region_id : [this.data.fk_region_id, Validators.compose([Validators.required])]
      });
    //console.log(this._statesForm);
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._MastersService.addStates(this._statesForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._MastersService.editStates(this._statesForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  

  onSubmit() {
    if(isNaN(this.data.state_id)) {
      var my_array = this._statesForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._MastersService.addMasterDetails(my_array,'STATES').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._MastersService.editMasterDetails(this._statesForm.value,'STATES').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._statesForm.reset();
  }
}

