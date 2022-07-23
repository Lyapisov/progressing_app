export class User {
  public readonly id: string;
  public readonly profileCreated: boolean;

  constructor(
    id: string,
    profileCreated: boolean,
  ) {
    this.id = id;
    this.profileCreated = profileCreated;
  }
}
