import {Component, OnInit} from "@angular/core";
import {GetMineProfileHandlerService} from "../../../../application/profile/get-mine-profile-handler.service";
import {Profile} from "../../../../application/profile/profile";

@Component({
  selector: 'app-profile-page',
  templateUrl: './profile-page.component.html',
  styleUrls: ['./profile-page.component.css']
})
export class ProfilePageComponent implements OnInit {
  constructor(
    private getMineProfileHandler: GetMineProfileHandlerService,
  ) {
  }

  public profileData: Profile|null = null;

  ngOnInit() {
    this.getMineProfile();
  }

  private getMineProfile()
  {
     this.getMineProfileHandler.execute()
       .subscribe((profile: Profile) => {
        this.profileData = profile;
       });
  }
}
