import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdTypeListComponent } from './pd-type-list.component';

describe('PdTypeListComponent', () => {
  let component: PdTypeListComponent;
  let fixture: ComponentFixture<PdTypeListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdTypeListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdTypeListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
