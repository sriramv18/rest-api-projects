import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RelationShipListComponent } from './relation-ship-list.component';

describe('RelationShipListComponent', () => {
  let component: RelationShipListComponent;
  let fixture: ComponentFixture<RelationShipListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RelationShipListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RelationShipListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
