import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LenderHierarchyListComponent } from './lender-hierarchy-list.component';

describe('LenderHierarchyListComponent', () => {
  let component: LenderHierarchyListComponent;
  let fixture: ComponentFixture<LenderHierarchyListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LenderHierarchyListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LenderHierarchyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
