import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LenderHierarchyDialogComponent } from './lender-hierarchy-dialog.component';

describe('LenderHierarchyDialogComponent', () => {
  let component: LenderHierarchyDialogComponent;
  let fixture: ComponentFixture<LenderHierarchyDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LenderHierarchyDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LenderHierarchyDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
