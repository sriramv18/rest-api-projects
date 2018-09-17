import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CustomerSegmentListComponent } from './customer-segment-list.component';

describe('CustomerSegmentListComponent', () => {
  let component: CustomerSegmentListComponent;
  let fixture: ComponentFixture<CustomerSegmentListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CustomerSegmentListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CustomerSegmentListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
