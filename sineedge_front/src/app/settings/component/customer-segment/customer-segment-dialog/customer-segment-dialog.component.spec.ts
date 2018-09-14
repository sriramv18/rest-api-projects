import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CustomerSegmentDialogComponent } from './customer-segment-dialog.component';

describe('CustomerSegmentDialogComponent', () => {
  let component: CustomerSegmentDialogComponent;
  let fixture: ComponentFixture<CustomerSegmentDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CustomerSegmentDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CustomerSegmentDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
