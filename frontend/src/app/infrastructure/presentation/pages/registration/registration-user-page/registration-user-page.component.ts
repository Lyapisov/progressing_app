import {Component, OnInit} from "@angular/core";
import {RegistrationHandlerService} from "../../../../../application/registration/registration-handler.service";
import {RegistrationFormData} from "../../../components/forms/registration-form/registration-form-data";
import {Router} from "@angular/router";
import {NotifierService} from "../../../../services/notifier/notifier.service";

@Component({
  selector: 'app-registration-user-page',
  templateUrl: './registration-user-page.component.html',
  styleUrls: ['./registration-user-page.component.scss']
})
export class RegistrationUserPageComponent implements OnInit {
  constructor(
    private registrationUserHandler: RegistrationHandlerService,
    private router: Router,
    private notifier: NotifierService,
  ) {
  }

  ngOnInit() {
  }

  onSubmit(data: RegistrationFormData): void {
    this.registrationUserHandler
      .execute(data.login, data.email, data.password, data.role)
      .subscribe(() => {
        this.router.navigate(['/']);
      });
  };
}
