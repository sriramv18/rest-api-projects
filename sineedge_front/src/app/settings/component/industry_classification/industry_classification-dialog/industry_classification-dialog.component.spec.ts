import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import {  IndustryMasterDialogComponent } from './industry-master-dialog.component';

describe('IndustryMasterDialogComponent ', () => {
  let component: IndustryMasterDialogComponent ;
  let fixture: ComponentFixture<IndustryMasterDialogComponent >;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ IndustryMasterDialogComponent  ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(IndustryMasterDialogComponent );
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
