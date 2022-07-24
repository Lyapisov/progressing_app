import {Component, OnInit} from "@angular/core";
import {GetMineUserHandlerService} from "../../../../application/users/get-mine-user-handler.service";
import {User} from "../../../../application/users/user";
import {GetFanProfileHandlerService} from "../../../../application/profiles/get-profile-handler.service";
import {Profile} from "../../../../application/profiles/profile";

@Component({
  selector: 'app-profile-page',
  templateUrl: './profile-page.component.html',
  styleUrls: ['./profile-page.component.scss']
})
export class ProfilePageComponent implements OnInit {
  constructor(
    private getMineUserHandler: GetMineUserHandlerService,
    private getFanProfileHandler: GetFanProfileHandlerService,
  ) {
  }

  public userData: User|null = null;
  public profileData: Profile|null = null;

  ngOnInit() {
    this
      .getMineUser()
      .then(user => this.findProfile(user))
  }

  private async getMineUser(): Promise<User> {
    let user;
    await this.getMineUserHandler.execute()
      .subscribe((foundUser: User) => {
        this.userData = foundUser;
        user = foundUser;
      });

    return user;
  }

  private findProfile(user: User): void {
    console.log(user);
    if (!user.profileCreated) {
      return;
    }

    if (user.fanId) {
      this.getFanProfileHandler.execute(user.fanId)
        .subscribe((fan: Profile) => {
          this.profileData = fan;
        })
    }
  }
}
