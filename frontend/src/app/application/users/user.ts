export class User {
  public readonly id: string;
  public readonly profileCreated: boolean;
  public readonly fanId: string|null;
  public readonly musicianId: string|null;
  public readonly producerId: string|null;


  constructor(
    id: string,
    profileCreated: boolean,
    fanId: string | null,
    musicianId: string | null,
    producerId: string | null
  ) {
    this.id = id;
    this.profileCreated = profileCreated;
    this.fanId = fanId;
    this.musicianId = musicianId;
    this.producerId = producerId;
  }
}
