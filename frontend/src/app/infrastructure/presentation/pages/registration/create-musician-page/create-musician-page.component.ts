import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {CreateProfileFormData} from "../../../components/forms/profile/create-profile-form/create-profile-form-data";
import {CreateMusicianHandlerService} from "../../../../../application/registration/create-musician-handler.service";

@Component({
  selector: 'app-create-musician-page',
  templateUrl: './create-musician-page.component.html',
  styleUrls: ['./create-musician-page.component.scss']
})
export class CreateMusicianPageComponent implements OnInit {
  constructor(
    private createMusicianHandler: CreateMusicianHandlerService,
    private router: Router,
  ) {
  }

  ngOnInit() {
  }

  onSubmit(data: CreateProfileFormData): void {
    this.createMusicianHandler
      .execute(
        data.firstName,
        data.lastName,
        data.fatherName,
        data.birthday,
        data.address,
        data.phone,
      )
      .subscribe(() => {
        this.router.navigate(['/profile/mine']);
      });
  };
}
