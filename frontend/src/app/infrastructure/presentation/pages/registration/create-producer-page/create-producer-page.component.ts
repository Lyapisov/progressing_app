import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {CreateProfileFormData} from "../../../components/forms/profile/create-profile-form/create-profile-form-data";
import {CreateProducerHandlerService} from "../../../../../application/registration/create-producer-handler.service";

@Component({
  selector: 'app-create-producer-page',
  templateUrl: './create-producer-page.component.html',
  styleUrls: ['./create-producer-page.component.scss']
})
export class CreateProducerPageComponent implements OnInit {
  constructor(
    private createProducerHandler: CreateProducerHandlerService,
    private router: Router,
  ) {
  }

  ngOnInit() {
  }

  onSubmit(data: CreateProfileFormData): void {
    this.createProducerHandler
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
