import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardRemoveModule extends VuexModule {
  private index!: number;
  private item = {
    account: '',
  };

  @Mutation
  public setIndex(index: any) {
    this.index = index;
  }

  @Mutation
  public setItem(item: any) {
    this.item = item;
  }
}
