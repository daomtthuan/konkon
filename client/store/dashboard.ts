import { Module, Mutation, VuexModule } from 'vuex-module-decorators';

@Module({
  stateFactory: true,
})
export default class DashboardModule extends VuexModule {
  private navbar = {
    breadcrumb: [],
  };

  @Mutation
  public setBreadcrumb(breadcrumb: any) {
    this.navbar.breadcrumb = breadcrumb;
  }
}
