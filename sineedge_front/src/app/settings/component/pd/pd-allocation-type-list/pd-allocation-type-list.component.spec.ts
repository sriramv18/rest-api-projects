import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdAllocationTypeListComponent } from './pd-allocation-type-list.component';

describe('PdAllocationTypeListComponent', () => {
  let component: PdAllocationTypeListComponent;
  let fixture: ComponentFixture<PdAllocationTypeListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdAllocationTypeListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdAllocationTypeListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
