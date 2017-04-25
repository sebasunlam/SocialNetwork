using System;
using System.Collections.Generic;
using System.Linq;
using System.Linq.Expressions;
using Incorporaciones.Dominio.Common.Contracts;
using Incorporaciones.Dominio.Entidades;
using Incorporaciones.Dominio.Extensions;
using Incorporaciones.Dominio.Repositorios.Contracts;
using Incorporaciones.Private.Servicio.Contracts;
using Incorporaciones.Private.Servicio.Exceptions;
using LinqKit;
using RefactorThis.EFExtensions;

namespace Incorporaciones.Private.Servicio.Implementation
{
    public class Servicio<T> : IServicio<T> where T : Entidad
    {
        #region Propiedades

        //protected readonly ILogger _logger;
        protected IRepositorio<T> Repositorio;
        protected readonly IUnitOfWork UnitOfWork;

        #endregion

        #region constructor

        public Servicio(IRepositorio<T> repositorio, IUnitOfWork unitOfWork)
        {
            Repositorio = repositorio;
            UnitOfWork = unitOfWork;
        }

        #endregion

        #region Metodos Publicos

        public T Get(long id)
        {
            var entity = Repositorio.Get(id);

            return entity;
        }

        public T Get(string id)
        {
            var entity = Repositorio.Get(id);
            return entity;
        }

        protected T Get(Expression<Func<T, bool>> predicate)
        {
            return GetAllItems().SingleOrDefault(predicate);
        }

        protected IQueryable<T> GetAllItems()
        {
            return GetAllItems(null);
        }

        protected IQueryable<T> GetAllItems(Expression<Func<T, bool>> predicate)
        {
            var query = Repositorio.GetAll();

            //todo: version que implementa IVisible para eliminar las referencias u objetos que tienen marca de no visibles
            //query = typeof(T).GetInterfaces().Contains(typeof(IVisible))
            //                                                ? query.Where(t => t.visible)
            //                                                : query;

            return predicate != null
                ? query.Where(predicate)
                : query;
        }

        public IQueryable<T> GetAllQueryable()
        {
            return GetAllItems();
        }

        public IList<T> GetAll()
        {
            return GetAllItems().ToList();
        }

        public IList<T> GetAllOrderedBy<TKey>(Expression<Func<T, TKey>> keySelector)
        {
            return GetAllItems().OrderBy(keySelector).ToList();
        }       

        public virtual void Create(T item, out long id)
        {
            Create(item);
            id = (long)item.GetType().GetProperty("Id").GetValue(item);
        }

        public virtual void Create(T item)
        {
            try
            {
                Repositorio.Add(item);
                UnitOfWork.SaveChanges();
            }
            //catch (DbEntityValidationException e)
            //{
            //	foreach (var eve in e.EntityValidationErrors)
            //	{
            //		Console.WriteLine("Entity of type \"{0}\" in state \"{1}\" has the following validation errors:",
            //			eve.Entry.Entity.GetType().Name, eve.Entry.State);
            //		foreach (var ve in eve.ValidationErrors)
            //		{
            //			Console.WriteLine("- Property: \"{0}\", Error: \"{1}\"",
            //				ve.PropertyName, ve.ErrorMessage);
            //		}
            //	}
            //	throw;
            //}
            catch (Exception ex)
            {
                //_logger.Debug(item.GetType() + " Error al crear:  " + ex.Message);
                throw new ServiceException("Ocurrio un error al crear el item", ex);
            }
        }

        public virtual bool Create(List<T> items)
        {
            try
            {
                var result = Repositorio.Add(items);
                UnitOfWork.SaveChanges();
                return result;
            }
            catch (Exception ex)
            {
                throw new ServiceException("Ocurrio un error al crear los items", ex);
            }


        }

        public virtual void Update(T item)
        {
            try
            {
                Repositorio.Update(item);
                UnitOfWork.SaveChanges();
            }
            catch (Exception ex)
            {
                //_logger.Debug(item.GetType() + " Error al editar:  " + ex.Message);
                throw new ServiceException("Ocurrio un error al editar el item", ex);
            }
        }

        protected virtual void Update(T item, Expression<Func<IUpdateConfiguration<T>, object>> mapping)
        {
            try
            {
                Repositorio.Update(item, mapping);
                UnitOfWork.SaveChanges();
            }
            catch (Exception ex)
            {
                //_logger.Debug(item.GetType() + " Error al editar:  " + ex.Message);
                throw new ServiceException("Ocurrio un error al editar el item", ex);
            }
        }

        public virtual void Delete(long id)
        {
            try
            {
                var item = Repositorio.Get(id);
                Repositorio.Delete(item);

                UnitOfWork.SaveChanges();
            }
            catch (Exception ex)
            {
                //_logger.Debug(item.GetType() + " Error al eliminar:  " + ex.Message);
                throw new ServiceException("Ocurrio un error al eliminar el item", ex);
            }
        }

        public virtual void DeleteChildren(long id)
        {
            try
            {
                var item = Repositorio.Get(id);
                Repositorio.DeleteChildren(item);

                UnitOfWork.SaveChanges();
            }
            catch (Exception ex)
            {
                //_logger.Debug(item.GetType() + " Error al eliminar:  " + ex.Message);
                throw new ServiceException("Ocurrio un error al eliminar el item", ex);
            }
        }

        public void CreateOrUpdate(T item)
        {

            if (Get(item.Id) == null)
                Create(item);
            else
                Update(item);
        }

        #endregion

    }
}