import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MembersOccupationDialogComponent } from './members-occupation-dialog.component';

describe('MembersOccupationDialogComponent', () => {
  let component: MembersOccupationDialogComponent;
  let fixture: ComponentFixture<MembersOccupationDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MembersOccupationDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MembersOccupationDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
