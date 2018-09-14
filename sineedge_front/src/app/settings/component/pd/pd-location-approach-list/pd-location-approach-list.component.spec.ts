import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdLocationApproachListComponent } from './pd-location-approach-list.component';

describe('PdLocationApproachListComponent', () => {
  let component: PdLocationApproachListComponent;
  let fixture: ComponentFixture<PdLocationApproachListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdLocationApproachListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdLocationApproachListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
