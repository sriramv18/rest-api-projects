import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
import { MastersService } from '../../../service/master/masters.service';
import { Branch,States,City } from '../../../model/branch';
import { Observable }   from 'rxjs/Observable';//for Datatables

@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './branch-dialog.component.html',
  styleUrls: ['./branch-dialog.component.scss']
})

export class BranchDialogComponent implements OnInit {

  
  public _branchForm: FormGroup;

  citydatas: City[];
  errorMessage:string;

  constructor(private _formBuilder: FormBuilder,
              private dialogRef: MatDialogRef<BranchDialogComponent>,
              private _mastersService: MastersService,
              @Inject(MAT_DIALOG_DATA) public data: Branch) { }

  
  ngOnInit() {

    this._branchForm = this._formBuilder.group({
      branch_id: [this.data.branch_id],
      name: [this.data.name, Validators.compose([Validators.required])],
      fk_city_id: [this.data.fk_city_id, Validators.compose([Validators.required])]
    });
    //console.log(this._branchForm);
    
    this._mastersService.getAllCityData()
        .subscribe(
            data => {
              
              this.citydatas = data;
              this.citydatas = this.citydatas.filter(city=>city.isactive == 1 );
              
            }, error => this.errorMessage = <any> error);
      
  }

  /** For Popup Close Button */
  onNoClick(): void {
    this.dialogRef.close();
  }

  /** To Save/Edited Popup Data */
  onSubmit() {

    var BranchFormValues = this._branchForm.value;

    if(isNaN(this.data.branch_id)) {
      
      Object.keys(BranchFormValues)
            .forEach((key) => ( BranchFormValues[key] == null) && delete BranchFormValues[key]);
      //console.log(BranchFormValues);
      this._mastersService.addMasterDetails(BranchFormValues,'BRANCH').subscribe();
      this.dialogRef.close();
      //alert("saved");
    } else {
      this._mastersService.editMasterDetails(BranchFormValues,'BRANCH').subscribe();
      this.dialogRef.close();
      //alert("edited");
    }
  }

  /** To Reset Popup Data */
  onReset(){
    this._branchForm.reset();
  }

}
