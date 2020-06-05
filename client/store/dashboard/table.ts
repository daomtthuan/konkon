import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardManageModule extends VuexModule {
  private items!: any[];

  @Mutation
  public setItems(items: any[]) {
    this.items = items;
  }

  @Mutation
  public editItem(payload: { index: number; item: any }) {
    Object.assign(this.items[payload.index], payload.item);
  }
}
