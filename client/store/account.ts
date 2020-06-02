import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class AccountModule extends VuexModule {
  private change = {
    information: false,
    password: false,
  };

  @Mutation
  public reverseChangeInformation() {
    this.change.information = !this.change.information;
  }

  public get isChangePassword() {
    return this.change.password;
  }

  @Mutation
  public reverseChangePassword() {
    this.change.password = !this.change.password;
  }
}
