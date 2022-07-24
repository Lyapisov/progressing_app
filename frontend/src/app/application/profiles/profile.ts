import {PersonalData} from "./personal-data";

export class Profile {
  public readonly id: string;
  public readonly personalData: PersonalData;

  constructor(
    id: string,
    personalData: PersonalData,
  ) {
    this.id = id;
    this.personalData = personalData;
  }
}
