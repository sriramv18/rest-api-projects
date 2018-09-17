import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MembersOccupationListComponent } from './members-occupation-list.component';

describe('MembersOccupationListComponent', () => {
  let component: MembersOccupationListComponent;
  let fixture: ComponentFixture<MembersOccupationListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MembersOccupationListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MembersOccupationListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
