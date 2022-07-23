import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {CreateFanHandlerService} from "../../../../../application/registration/create-fan-handler.service";
import {CreateProfileFormData} from "../../../components/forms/create-profile-form/create-profile-form-data";

@Component({
  selector: 'app-create-fan-page',
  templateUrl: './create-fan-page.component.html',
  styleUrls: ['./create-fan-page.component.scss']
})
export class CreateFanPageComponent implements OnInit {
  constructor(
    private createFanHandler: CreateFanHandlerService,
    private router: Router,
  ) {
  }

  ngOnInit() {
  }

  onSubmit(data: CreateProfileFormData): void {
    this.createFanHandler
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
