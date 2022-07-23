import {Component, OnInit} from "@angular/core";
import {GetMineUserHandlerService} from "../../../../application/users/get-mine-user-handler.service";
import {User} from "../../../../application/users/user";

@Component({
  selector: 'app-profile-page',
  templateUrl: './profile-page.component.html',
  styleUrls: ['./profile-page.component.css']
})
export class ProfilePageComponent implements OnInit {
  constructor(
    private getMineProfileHandler: GetMineUserHandlerService,
  ) {
  }

  public profileData: User|null = null;

  ngOnInit() {
    this.getMineProfile();
  }

  private getMineProfile()
  {
     this.getMineProfileHandler.execute()
       .subscribe((profile: User) => {
        this.profileData = profile;
       });
  }
}
