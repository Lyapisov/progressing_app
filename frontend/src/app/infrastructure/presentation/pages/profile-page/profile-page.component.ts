import {Component, OnInit} from "@angular/core";
import {EditProfileFormData} from "../../components/forms/profile/edit-profile-form/edit-profile-form-data";

@Component({
  selector: 'app-profile-page',
  templateUrl: './profile-page.component.html',
  styleUrls: ['./profile-page.component.scss']
})
export class ProfilePageComponent implements OnInit {
  constructor(
  ) {
  }

  ngOnInit() {
  }

  public onEdit(event: EditProfileFormData): void {

  }
}
