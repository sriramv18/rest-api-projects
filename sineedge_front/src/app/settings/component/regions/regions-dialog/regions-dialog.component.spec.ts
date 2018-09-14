import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RegionsDialogComponent } from './regions-dialog.component';

describe('RegionsDialogComponent', () => {
  let component: RegionsDialogComponent;
  let fixture: ComponentFixture<RegionsDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RegionsDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RegionsDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
